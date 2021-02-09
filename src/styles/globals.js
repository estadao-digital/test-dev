import { createGlobalStyle } from 'styled-components'

const GlobalStyles = createGlobalStyle`
  html,
  body {
    padding: 0;
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen,
      Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif;
    box-sizing: border-box;
    background: #f1f1f1;
  }

  a {
    color: inherit;
    text-decoration: none;
  }

  * {
    box-sizing: border-box;
  }
  .logo{
    position: relative;
    width: 220px;
    height: 64px;
    background-size: 100%;
    background-image: url('logo-estadao-cavalo.svg');
    background-repeat: no-repeat;
    text-indent: -9999px;
    overflow: hidden;
    margin: 0 auto;
    small {
      position: absolute;
      top: 44px;
      left: 128px;
      color: #666;
      font-size: 18px;
      text-indent: 0;
    }
  }
  .container {
    background-color: #fff;
  }
  .col-md-3.col-sm-12 {
    height: calc(100vh);
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .btn__start {
    display: block;
    margin: 0 auto;
  }
`

export default GlobalStyles
