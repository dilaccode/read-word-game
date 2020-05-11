# logic design temp
(Add new on top)
## 4. problems (temp, will delete)
1. delete/edit wrong word/mean
## 3. optimize game for easy first
- [x] simple model, split controller
- [x] view short word first, view longer word later
    - [ ]mix 2,3,4 letter word...
- [ ] make achievement / level
- [ ] image
## 2. improve to like game application
1. focus learn 1 word for master
2. exp/level system
3. UX improve
4. **=> remove click on mean, replate new process:**
    - show mean no links
    - show related word as button
    - back to main word > it mean view relate word no view more.
    - easy exp system, bonus user for excited
5. more improve
    - [ ] update word mean (definition)
    - [ ] add new mean (definition) for empty word
        - collect empty word
        - show on file or page
        - use Google Diction find mean
        - import to system
## 1. database 
1. word table
    * word
    * mean
    * count (level)
        * count all word lower/min is your level.
2. import data from Google Dictionary
    * CSV file 4 column
        * use PHP for import
            * read data
                - [ ] way 1: upload file to server, read file
                - [x] way 2: copy file data and add to text area
            * process data
            * add to database
