import { createGlobalStyle } from 'styled-components';
import 'bootstrap/dist/css/bootstrap.min.css';

export default createGlobalStyle`

  * {
    margin:0;
    padding:0;
    outline:0;
    box-sizing: border-box;
  }

   a {
    text-decoration:none;
  }

  button {
    cursor:pointer;
  }

  html {
  font-family: 'Roboto', sans-serif;
  -webkit-font-smoothing: antialiased;
  height: 100%;
}

body, h1, h2, h3, h4, h5, h6 {
  font-size: 15px;
  margin: 0;
  line-height: 24px;
}

body {
  margin: 0;
  background-color: #efefef;
}

body, html, #app, #app > div{
  height: 100%;
}



`;
