<!DOCTYPE html>
<html lang=en>
<head>
    <title>Single Painting</title>
    <meta charset=utf-8>
    <script src="js/single-painting.js"></script>
    <link rel="stylesheet" href="css/single-painting.css">
</head>
<body>
    <div class="header"></div>
    <div class="container">
        <div class="section" id="painting-section">
            <img id="image" src=""/>
        </div>
        <div class="section data-container">
            <div class="data-section">
                <p class="heading" id="title"></p>
                <p class="sub-heading" id="artist"></p>
                <p class="sub-heading" id="gallery-year"></p>
                <button id="add-to-favorites">Add To Favorites</button>
            </div>
            <div class="data-section">
                <div id="tab-button-bar">
                    <button class="tab-button open" title="description">Description</button>
                    <button class="tab-button" title="details">Details</button>
                    <button class="tab-button" title="colors">Colors</button>
                </div>
                <div class="tab visible" id="description-tab">
                    <p id="description"></p>
                </div>
                <div class="tab" id="details-tab">
                    <strong>Medium: </strong><span id="medium"></span><br/>
                    <strong>Width: </strong><span id="width"></span><br/>
                    <strong>Height: </strong><span id="height"></span><br/>
                    <strong>Copyright: </strong><span id="copyright"></span><br/>
                    <strong>WikiLink: </strong><a id="wiki-link" href=""></a><br/>
                    <strong>Museum Link: </strong><a id="museum-link" href=""></a><br/>
                </div>
                <div class="tab" id="colors-tab"></div>
            </div>
        </div>
    </div>
</body>
</html>