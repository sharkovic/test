<?php

class basePeople

{
  public $path;
  public $peopleData = array();
  public function __construct($path = '')
  {
    if ($path != '') {
      $this->setPath($path);
    }
  }

  public function setPath($path)
  {
    if (file_exists($path)) {
      $file = file_get_contents($path, true);
      $this->peopleData = json_decode($file, true);
      $this->path = $path;
    } else {
      $this->path = '';
      $this->isPath();
    }
  }

  public function isPath()
  {
    if ($this->path == '') {
      echo 'Путь к файлу отсутствует или указан не верно';
    }
    return $this->path != '';
  }

  public function showListPeople()
  {
    if (!$this->isPath()) {
      exit;
    }
    foreach ($this->peopleData as $k => $v) {
      echo $k + 1 . ') ' . 'ФИО: ' . $v['fio'] . ' ' . '<br>Возраст: ' . $v['age'] . ' ' . '<br>Профессия: ' . $v['prof'] . '<p>';
    }
  }

  public function addPerson($fio, $age = '', $prof = '')
  {
    if (!$this->isPath()) {
      exit;
    }
    $array = [
      "fio" => $fio,
      "age" => $age,
      "prof" => $prof
    ];
    array_push($this->peopleData, $array);
  }
  public function saveFile()
  {
    if (!$this->isPath()) {
      exit;
    }
    $json = json_encode($this->peopleData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json) {
      file_put_contents($this->path, $json) or die("не удалось сохранить в файл");
    }
  }

  public function clearAllPerson()
  {
    if (!$this->isPath()) {
      exit;
    }
    $this->peopleData = array();
  }

  public function deletePerson($fio = '', $age = '', $prof = '')
  {
    if (!$this->isPath()) {
      exit;
    }
    $array = array();
    if ($fio != '') {
      $array['fio'] = $fio;
    }
    if ($age != '') {
      $array['age'] = $age;
    }
    if ($prof != '') {
      $array['prof'] = $prof;
    }
    echo count($array);
    foreach ($this->peopleData as $key => $value) {
      $new = array_intersect_assoc($value, $array);
      if (count($array) == count($new)) {
        unset($this->peopleData[$key]);
      }
    };
    $this->peopleData = array_values($this->peopleData);
  }
}
