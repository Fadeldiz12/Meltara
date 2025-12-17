<?php
namespace App\Models;


use CodeIgniter\Model;


class SettingsModel extends Model
{
protected $table = 'settings';
protected $primaryKey = 'id';
protected $allowedFields = ['key_name','value','description','users_id'];


public function getValue(string $key, $default = null)
{
$row = $this->where('key_name', $key)->first();
return $row ? $row['value'] : $default;
}


public function setValue(string $key, $value, $description = null)
{
$exists = $this->where('key_name', $key)->first();
if ($exists) {
return $this->update($exists['id'], ['value' => (string)$value, 'description' => $description]);
}
return $this->insert(['key_name' => $key, 'value' => (string)$value, 'description' => $description]);
}
}