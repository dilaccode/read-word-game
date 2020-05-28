# Interesting word game
## read article mode
## some information
1. make people read all mean (definition) sentences.<br>
  /make people interesting read all mean sentences.
2. collect action
  - words
  - some items/ some things
3. type: puzzle
4. user flow
  - user solve puzzle
  - and fight with others users
      - fake users (AI) with win/lose flow for make user interesting
5. game play (update temp)
  - auto select mean from left to right.
  - when finish, move to next word
  - option:
    - zoom word
    - or make a map like
      main word
          |
    |     |     |
  word1 word2 word3


6. level system
  1. exp = word length (1-500...X)
  2. level
    1. level should few exp for **make earn feeling** by run long distance.
      - ex: level 1-10 should 1 word = 10-30%...X
  3. [Sheet Calculate](https://docs.google.com/spreadsheets/d/1SyvnZhWRSl8t_61NNYMaSLoYHVY_3jGltsi_uI3IyXo/edit?usp=sharing)
  4. ... 
    - level
      - total exp -> current exp -> percent 
      - 
    - next level , next exp -> level exp

  7. Learn Scenario
    - read word by scenario X, ex: Personal MBA article


  8. temp, get mean from cambridge
  javascript:(function(){  })();

  https://dictionary.cambridge.org/vi/dictionary/english/WORD
  word(no need): $(".headword").textContent
  mean: $(".def-block").textContent

  get on bookmark, url: EDIT on assets/js/Temp.js
    javascript:(function(){  var text = document.getElementsByClassName("def-block")[0].innerText; var textEncode = encodeURI(text); alert(decodeURI(textEncode));  })();
  - sign remove: A1.. B2
  - sign split
    - Từ đồng nghĩa
    - 