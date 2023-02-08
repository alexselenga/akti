<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductParseService extends ParseService
{
    public function __construct(protected $modelClass = Product::class, protected $delimiter = ';')
    {
        parent::__construct($modelClass, $delimiter);
    }

    protected function correctValues(array &$keyValues)
    {
        $keyValues['code'] = str_replace('"', '', $keyValues['code']);
        $keyValues['price_sp'] = str_replace(',"', ',', $keyValues['price_sp']);
        $keyValues['unit'] = str_replace('""', '', $keyValues['unit']);
        $keyValues['description'] = str_replace("\r", '', $keyValues['description']);
        $keyValues['description'] = str_replace(",,", '', $keyValues['description']);
        if($keyValues['description'] == '",') $keyValues['description'] = '';
        if($keyValues['description'] == '"') $keyValues['description'] = '';
    }

    protected function validate(array $keyValues)
    {
        $validator = Validator::make($keyValues, [
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'numeric',
            'price_sp' => 'numeric',
            'amount' => 'integer',
            'show_on_main' => 'integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function put(string $fromCSVFileName, string $toJSONFileName)
    {
        $path = storage_path("app/$fromCSVFileName");
        $text = file_get_contents($path);
        $productCollection = $this->parse($text);
        $json = $productCollection->toJSON(JSON_PRETTY_PRINT);
        Storage::disk('local')->put($toJSONFileName, $json);
    }

    public function get(string $JSONfileName)
    {
        $fs = Storage::disk('local');
        if(!$fs->exists($JSONfileName)) return [];
        $json = $fs->get($JSONfileName);
        return json_decode($json);
    }
}
