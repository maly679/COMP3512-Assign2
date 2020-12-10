body {
	background-image: url("../images/unsplash-main.jpg");
	font-family: Open Sans, sans-serif;
	/* font-size: 0.8rem; */
	overflow-x: hidden;
	margin-right: 29px;
  }
  
  /* body {
	  background-color: steelblue;
	  font-family: Open Sans, sans-serif;
	  font-size: 0.8rem;
	} */
	.largeImgView {
		height: 100%;
		width: 100%;
	}
  .container {
	display: grid;
	grid-template-columns: 50% 50%;
	grid-template-rows: 250px 400px minmax(400px, auto);
	grid-gap: 10px;
	color: #444;
  }
  
  /* .container {
		display: grid;
		padding: 40px;
		grid-gap: 10px;
		color: #444;
		grid-template-areas:
		  "header header header"
		  "welcome browse browse"
		  "favorites likes likes";
		grid-template-columns: 1fr 1fr 1fr;
		grid-template-rows: 6.5rem 25rem auto;
	 } */
  
  .a {
	grid-area: header;
  }
  
  .b {
	grid-area: welcome;
  }
  
  .c {
	grid-area: browse;
	display: grid;
	overflow: auto;
  }
  
  .d {
	grid-area: favorites;
  }
  
  .e {
	grid-area: likes;
  }
  
  .box {
	background-color: steelblue;
	color: black;
	border-radius: 5px;
	padding: 20px;
	font-size: 150%;
  }
  
  .h {
	grid-column: 1 / span 3;
	text-align: center;
	color: white;
  }
  
  h2,
  h3 {
	text-align: center;
  }
  
  .WelcomeUser {
	grid-column: 1 / span 1;
	grid-row-start: 2;
	grid-row-end: 3;
	text-align: center;
  }
  
  .searchFavorite {
	grid-column: 2 / span 1;
	grid-row-start: 2;
	grid-row-end: 3;
  }
  
  .Results {
	grid-column: 2 / span 1;
	grid-row-start: 3;
	grid-row-end: 4;
  }
  
  .searchFavoritesBox {
	/* height: 60px; */
	width: 200px;
	font-size: 16px;
  }
  
  button {
	border-radius: 5px;
	color: black;
	display: inline-block;
	padding: 2px 8px;
	background: white;
	border-style: solid;
	border-width: 1px;
	text-decoration: none;
	height: 25px;
  }
  
  #Favorites {
	grid-column: 1 / span 1;
	grid-row-start: 3;
	grid-row-end: 4;
  }
  
  li {
	display: inline-block;
	padding: 25px;
	width: 250px;
	align-items: center;
  }
  
  .navBtn {
	float: left;
	display: block;
	color: white;
	text-decoration: none;
	list-style: none;
	cursor: pointer;
	padding: 20px;
  }
  
  .navItems > div > div > ul > li {
	display: inline;
	width: 0px;
	color: white;
	list-style: none;
	padding: 0px;
  }
  
  #logo {
	float: right;
	width: 300px;
  }
  
  .navItems > div > div > ul {
	padding: 0;
	margin: 0;
  }
  
  .navBtn:hover {
	background-color: steelblue;
  }
  
  #menuIcon,
  .toggler {
	display: none;
  }
  
  i {
	font-style: normal;
  }
  
  .footer {
	grid-area: footer;
	text-align: center;
	color: white;
	padding: 20px;
	width: 100%;
  }
  
  /* Purposedly leaving underline on to indicate a link */
  
  .footer > p > a {
	color: white;
  }
  
  @media screen and (max-width: 800px) {
	/* .container {
		display: grid;
		grid-template-rows: 8em 22em 30em;
		grid-template-areas:
		  "header"
		  "form"
		  "info";
		grid-template-columns: 1fr;
		grid-gap: 10px;
	  } */
	.navContainer {
	  top: 0;
	  left: 0;
	  right: 0;
	  z-index: 1;
	}
	.navBtn {
	  float: none;
	}
	.toggler {
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 2;
	  cursor: pointer;
	  width: 50px;
	  height: 50px;
	  opacity: 0;
	  display: block;
	}
	#menuIcon {
	  display: block;
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 0;
	  cursor: pointer;
	  width: 50px;
	  height: 50px;
	  margin: 10px;
	  font-size: 20px;
	}
	#logo {
	  float: right;
	  margin: 10px;
	  width: 200px;
	}
	.navItems {
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 0;
	  overflow: hidden;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	}
	.navItems > div {
	  background: rgba(0, 0, 0, 0.8);
	  width: 200vw;
	  height: 100%;
	  display: flex;
	  flex: none;
	  align-items: center;
	  justify-content: center;
	}
	.navItems > div > div {
	  text-align: center;
	  max-width: 90vw;
	  max-height: 100vh;
	  opacity: 0;
	  transition: opacity 0.4s ease;
	}
	.navItems > div > div > ul > li {
	  list-style: none;
	  color: white;
	  padding: 1rem;
	}
	.navItems > div > div > ul > li > a {
	  color: inherit;
	  text-decoration: none;
	  transition: color 0.4s ease;
	}
	/* Show menu on toggle on*/
	.navItems .toggler:checked {
	  visibility: visible;
	}
	.toggler:checked ~ .navItems {
	  height: 100%;
	}
	.toggler:checked ~ .navItems > div > div {
	  opacity: 1;
	  transition: opacity 0.4s ease;
	}
	.fa {
	  font-size: 20px;
	}
	.button {
	  width: 100px;
	}
	.searchContainer input[type="text"] {
	  width: 300px;
	}
	.container {
		display: grid;
		padding: 20px;
		grid-template-columns:100%;
		grid-template-rows: auto auto auto auto auto;
		grid-gap: 10px;
		color: #444;
	  }


	  .h {
		grid-column: 1 / span 1;
		text-align: center;
		color: white;
		grid-row-start: 1;
		grid-row-end: 2;
	  }

	  .WelcomeUser {
		grid-column: 1 / span 1;
		grid-row-start: 2;
		grid-row-end: 3;
		text-align: center;
	  }

	  .largeImgView {
		  height: 98%;
		  width: 98%;
	  }
	  
	  .searchFavorite {
		grid-column: 1 / span 1;
		grid-row-start: 3;
		grid-row-end: 4;
	  }
	  .Results {
		grid-column: 1 / span 1;
		grid-row-start: 5;
		grid-row-end: 6;
	  }
	  #Favorites {
		grid-column: 1 / span 1;
		grid-row-start: 4;
		grid-row-end: 5;
	  }
  }
  
  /* For smaller mobile screens */
  
  @media screen and (max-width: 400px) {
	.container {
		display: grid;
		padding: 20px;
		grid-template-columns:100%;
		grid-template-rows: auto 20% auto auto auto;
		grid-gap: 10px;
		color: #444;
	  }
	  .largeImgView {
		height: 98%;
		width: 98%;
	}
	

	  .h {
		grid-column: 1 / span 1;
		text-align: center;
		color: white;
		grid-row-start: 1;
		grid-row-end: 2;
	  }

	  .WelcomeUser {
		grid-column: 1 / span 1;
		grid-row-start: 2;
		grid-row-end: 3;
		text-align: center;
	  }
	  
	  .searchFavorite {
		grid-column: 1 / span 1;
		grid-row-start: 3;
		grid-row-end: 4;
	  }
	  .Results {
		grid-column: 1 / span 1;
		grid-row-start: 5;
		grid-row-end: 6;
	  }
	  #Favorites {
		grid-column: 1 / span 1;
		grid-row-start: 4;
		grid-row-end: 5;
	  }
	  
	  
  }
  
