<?php
// find exmaple by word
"Select * from example where"
                            . " Example Like '%$SPACE$WordSearch$SPACE%'" // middle
                            . " OR Example Like '%$WordSearch$SPACE%'" // first
                            . " OR Example Like '%$SPACE$WordSearch.%'" // last
                            . " OR Example Like '%$SPACE$WordSearch,%'" // middle
                            . " OR Example Like '%$SPACE$WordSearch!%'"
                            . " OR Example Like '%$SPACE$WordSearch?%'"
                            . " LIMIT 3";

// 