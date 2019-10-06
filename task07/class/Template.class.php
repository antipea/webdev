<?php
declare(strict_types=1);
class Template
{
    private $content;
    private $placeholders = array();
    private $labels = array();

    public function __construct()
    {
    }

    public function setTpl ($tpl)
    {    if (!is_file($tpl)) {
            throw new Exception('Main template [' . $tpl . '] not found.');
        }
        $this->content = file_get_contents($tpl);
    }
    public function setPlhOne(string $name, string $value)
    {
        $this->content = str_replace($name, $value, $this->content);
    }

    public function setPlhMany(string $name, string $value)
    {
        $this->placeholders[$name] = $value;
    }

    public function setLb(array $labels_array)
    {
        $this->labels = $labels_array;
    }

    private function processDV(array $dv)
    {
        $placeholder_name = $dv[1];
        if (isset($this->placeholders[$placeholder_name])) {
            return $this->placeholders[$placeholder_name];
        } else {
            throw new Exception('Placeholder [' . $placeholder_name . '] not found.');
        }
    }

    private function processLabels(array $lb)
    {
        $label_name = $lb[1];
        if (isset($this->labels[$label_name])) {
            return $this->labels[$label_name];
        } else {
            throw new Exception('Label [' . $label_name . '] not found.');
        }
    }

    private function parseTpl (array $tn)
    {
        $subtemplate_name = 'templates/' . $tn[1];
        if (is_file($subtemplate_name)) {
            return file_get_contents($subtemplate_name);
        } else {
            throw new Exception('Subtemplate [' . $subtemplate_name . '] not found.');
        }
    }

    public function processTemplate()
    {
        while (preg_match("/{FILE=\"(.*)\"}|{DV=\"(.*)\"}|{LABEL=\"(.*)\"}/Ui", $this->content)) {
            $this->content = preg_replace_callback("/{DV=\"(.*)\"}/Ui", array($this, 'processDV'), $this->content);
            $this->content = preg_replace_callback("/{LABEL=\"(.*)\"}/Ui", array($this, 'processLabels'), $this->content);
            $this->content = preg_replace_callback("/{FILE=\"(.*)\"}/Ui", array($this, 'processSubtemplates'), $this->content);
        }
    }

    public function ourContent (bool $remove_comments = true, bool $compress = true)
    {
        $temp = $this->content;
        if ($remove_comments == true) {
            $temp = preg_replace("/<!--.*-->/sU", "", $temp);
        }

        if ($compress == true) {
            while (strpos($temp, '  ') !== false) {
                $temp = str_replace('  ', ' ', $temp);
            }

            while (strpos($temp, "\r\r") !== false) {
                $temp = str_replace("\r\r", "\r", $temp);
            }

            while (strpos($temp, "\n\n") !== false) {
                $temp = str_replace("\n\n", "\n", $temp);
            }

            while (strpos($temp, "\r\n\r\n") !== false) {
                $temp = str_replace("\r\n\r\n", "\r\n", $temp);
            }
        }

        return $temp;
    }
 }
