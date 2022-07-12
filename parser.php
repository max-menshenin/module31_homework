<?php

class MetaIterator
{
    private $patterns = array('~<meta .*>~mui', '~<title>.*<\/title>~mui');
    private $array = [];
    public function __construct(string $text)
    {
        foreach ($this->patterns as $pattern) {
            preg_match_all($pattern, $text, $matches);
            $this->array = array_merge($this->array, $matches);
        }
    }
    private function recursiveScan($array)
    {
        $iterator = new RecursiveArrayIterator($array);
        while ($iterator->valid()) {
            if ($iterator->hasChildren()) {
                $this->recursiveScan(iterator_to_array($iterator->getChildren()));
            } else {
                echo htmlspecialchars($iterator->current()) . '<br>';
            }
            $iterator->next();
        }
    }
    public function getTagList()
    {
        $this->recursiveScan($this->array);
    }
}
$code = file_get_contents('index.html');
$scan = new MetaIterator($code);
$result = $scan->getTagList();




