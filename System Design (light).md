# Split to Server/Client architecture
- SOURCE FOLDER/
    - SERVER
        - PHP CI 4 files
        - use **other domain**: **http://DOMAIN/api** or **/api**
    - CLIENT
        - HTML, CSS, JSS files
        - ASSETS (images, fonts)  files        
        - Example design:<br>
          ../
            - index.html (Player.html)
            - Screen
                - Home.html
                - Word.html
                - Search.html (not sure)
                - ...
            - JS
                - Core.js
                - Player.js
                - Home.js
                - Word.js
            - CSS
                Core.css
                Phone.css
                TabletAndPc.css
            - Images
            - Fonts
        - use **main domain**: **http://DOMAIN** or **/**
    - Others files:
        - .md (markdown) for document
        - .bat .bash for online server
        - and more...
