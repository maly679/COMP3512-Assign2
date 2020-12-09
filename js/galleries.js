let map;
function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 41.89474, lng: 12.4839 },
        mapTypeId: "satellite",
        zoom: 18
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const galleryDataKey = "galleryData";
    const galleryEndpoint = 'api-galleries.php';
    const paintingsEndpoint = "api-paintings.php?gallery=";
    const paintingImagesEndpoint = "images/paintings/square/";
    let galleries = [];
    let paintings = [];
    let savedData = window.localStorage.getItem(galleryDataKey);

    if (savedData != null) {
        console.log("retrieved saved data");
        loadGalleryData(JSON.parse(savedData));
    }
    else {
        console.log("no saved data");
        fetch(galleryEndpoint)
        .then((response) => {
            document.querySelector("#loader1").style.display = "inline-block";
            return response.json();
        })
        .then((data) => {
            window.localStorage.setItem(galleryDataKey, JSON.stringify(data));
            console.log("saved to local storage");
            loadGalleryData(data);
        })
        .catch((error) => console.error(error));
    }
    
    toggleGalleryList();

    document.querySelector("#galleryList").addEventListener("click", (e) => {
        if (e.target.nodeName == "LI") {
            paintings = [];
            changeMap(e);
            let galleryID = e.target.getAttribute("data-key");

            fetch(paintingsEndpoint + galleryID)
            .then((response) => {
                document.querySelector("#loader1").style.display = "inline-block";
                document.querySelector("#loader2").style.display = "inline-block";

                return response.json();
            })
            .then((data) => {
                document.querySelector("#paintingsList").innerHTML = " ";
                document.querySelector("#loader1").style.display = "none";
                document.querySelector("#loader2").style.display = "none";

                document.querySelector("div.a section").style.display = "block";
                document.querySelector("div.c section").style.display = "grid";

                let foundGallery;
                for (gallery of galleries) {
                    if (gallery.GalleryID == galleryID) {
                        foundGallery = gallery;
                    }
                }
                changeGalleryDetails(foundGallery);

                let paintingsListHeader = document.createElement("tr");
                paintingsListHeader.innerHTML = `<th></th><th id="tableArtist">Artist</th><th id="tableTitle">Title</th><th id="tableYear">Year</th>`;
                document.querySelector("#paintingsList").appendChild(paintingsListHeader);
                paintings.push(...data); //inputs paintings objects into

                // sorting by artist last name by default
                paintings = paintings.sort(function (a, b) {
                    if (a.LastName < b.LastName) return -1;
                    else if (a.LastName > b.LastName) return 1;
                    else return 0;
                });

                paintings.forEach((painting) => {
                    let paintingsListItem = document.createElement("tr");
                    var html = "";
                    html += "<td><a href='single-painting.php?id=" + painting.PaintingID + "'>";
                    html += "<img id='listPainting' src='" + paintingImagesEndpoint + getFileName(painting.ImageFileName) + "'/>";
                    html += "</a></td>";
                    html += "<td>" + painting.LastName + "</td>";
                    html += "<td><a class='paintingTitle' href='single-painting.php?id=" + painting.PaintingID + "'>" + painting.Title + "</a></td>";
                    html += "<td>" + painting.YearOfWork + "</td>";
                    paintingsListItem.innerHTML = html; 
                    document.querySelector("#paintingsList").appendChild(paintingsListItem);
                });
            })
            .catch((error) => console.error(error));
        }
    });

    function getSavedData(key) {
        return window.localStorage.getItem(key);
    }
        
    function loadGalleryData(galleryData) {
        document.querySelector("#loader3").style.display = "none";
        document.querySelector("div.b section").style.display = "block";
        document.querySelector("#galleryList").style.display = "block";

        galleries.push(...galleryData); //fill galleries array with data

        // galleries were already sorted by gallery name but we sorted anyways per asg specs
        galleries = galleries.sort(function (a, b) {
            if (a.GalleryName < b.GalleryName) return -1;
            else if (a.GalleryName > b.GalleryName) return 1;
            else return 0;
        });

        galleries.forEach((gallery) => {
            let galleryListItem = document.createElement("li");
            galleryListItem.textContent = gallery.GalleryName;
            galleryListItem.setAttribute("data-key", gallery.GalleryID);
            galleryListItem.setAttribute("data-longitude", gallery.Longitude);
            galleryListItem.setAttribute("data-latitude", gallery.Latitude);
            document.querySelector("#galleryList").appendChild(galleryListItem);

            //https://davidwalsh.name/event-delegate
        });
        
    }
    
    function getFileName(fileName) {
        let length = fileName.toString().length;
        let diff = 6 - length;

        var newFileName = "";
        for (i=0;i<diff;i++) {
            newFileName += "0";
        }

        newFileName += fileName + ".jpg";
        return newFileName;
    }

    document.querySelector("#paintingsList").addEventListener("click", (e) => {
        if (e.target && e.target.matches("#tableYear")) {
            document.querySelector("#paintingsList").innerHTML = " ";
            paintings = paintings.sort(function (a, b) {
                if (a.YearOfWork < b.YearOfWork) return -1;
                else if (a.YearOfWork > b.YearOfWork) return 1;
                else return 0;
            });
            generatePaintingsList(paintings);
        }
        
        if (e.target && e.target.matches("#tableArtist")) {
            document.querySelector("#paintingsList").innerHTML = " ";
            paintings = paintings.sort(function (a, b) {
                if (a.LastName < b.LastName) return -1;
                else if (a.LastName > b.LastName) return 1;
                else return 0;
            });
            generatePaintingsList(paintings);
        }
        
        if (e.target && e.target.matches("#tableTitle")) {
            document.querySelector("#paintingsList").innerHTML = " ";
            paintings = paintings.sort(function (a, b) {
                if (a.Title < b.Title) return -1;
                else if (a.Title > b.Title) return 1;
                else return 0;
            });
            generatePaintingsList(paintings);
        }
    });

    function generatePaintingsList(paintings) {
        
        let paintingsListHeader = document.createElement("tr");
        paintingsListHeader.innerHTML = `<th></th><th id="tableArtist">Artist</th><th id="tableTitle">Title</th><th id="tableYear">Year</th>`;
        document.querySelector("#paintingsList").appendChild(paintingsListHeader);
        paintings.forEach((painting) => {
            let paintingsListItem = document.createElement("tr");
            var html = "";
            html += "<td><a href='single-painting.php?id=" + painting.PaintingID + "'>";
            html += "<img id='listPainting' src='" + paintingImagesEndpoint + getFileName(painting.ImageFileName) + "'/>";
            html += "</a></td>";
            html += "<td>" + painting.LastName + "</td>";
            html += "<td><a href='single-painting.php?id=" + painting.PaintingID + "'>" + painting.Title + "</a></td>";
            html += "<td>" + painting.YearOfWork + "</td>";
            paintingsListItem.innerHTML = html;
            document.querySelector("#paintingsList").appendChild(paintingsListItem);
        });
    }
}); // dom content loaded

// hides and shows gallery list with button click
function toggleGalleryList() {
    const toggleButton = document.querySelector("#toggleButton");

    toggleButton.addEventListener("click",(e) => {
        let galleryColumn = document.querySelector("div.b");
        galleryColumn.classList.toggle("hidden");

        if (toggleButton.value == "Show Galleries") {
            toggleButton.value = "Hide Galleries";
            document.querySelector(".container").style.gridTemplateColumns =
            "1fr 1fr 1fr 1fr";
        } else if (toggleButton.value == "Hide Galleries") {
            toggleButton.value = "Show Galleries";
            document.querySelector(".container").style.gridTemplateColumns =
            "0fr 1fr 1fr 1fr";
        }

        e.stopPropagation();
    }, { capture: true }
    );
}

function changeGalleryDetails(gallery) {
    document.querySelector("#galleryName").textContent = gallery.GalleryName;
    document.querySelector("#galleryNative").textContent = gallery.GalleryNativeName;
    document.querySelector("#galleryCity").textContent = gallery.GalleryCity;
    document.querySelector("#galleryAddress").textContent = gallery.GalleryAddress;
    document.querySelector("#galleryCountry").textContent = gallery.GalleryCountry;
    document.querySelector("#galleryHome").textContent = gallery.GalleryWebSite;
    // Set GalleryWebSite to a working link
    document.querySelector("#galleryHome").href = gallery.GalleryWebSite;
    // optional. Opens page in new tab
    document.querySelector("#galleryHome").setAttribute("target", "_blank");
}

// used this site to help with paseFloat problem.
//https://stackoverflow.com/questions/44878472/errorinvalidvalueerror-setcenter-not-a-latlng-or-latlngliteral-in-property-l
function changeMap(e) {
    let longitude = e.target.getAttribute("data-longitude");
    let latitude = e.target.getAttribute("data-latitude");
    longitude = parseFloat(longitude);
    latitude = parseFloat(latitude);
    map.setCenter({ lat: latitude, lng: longitude });
    map.setZoom(18);
}
// this site helped me look up stuff about google maps methods
// https://developers.google.com/earth-engine/apidocs/map-setzoom

// live share invite
//https://prod.liveshare.vsengsaas.visualstudio.com/join?3E5F5978CF97248E71E34EBAA2D405F28718

//https://prod.liveshare.vsengsaas.visualstudio.com/join?A6967840FF3762950676184131CF3D0C6801
