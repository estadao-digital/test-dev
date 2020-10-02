import { createGlobalStyle } from 'styled-components';

export default createGlobalStyle`
  *, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  html {
    font-size: 62.5%;
    -webkit-text-size-adjust: 100%;
    -moz-text-size-adjust: 100%;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
    -mox-osx-font-smooting: grayscale;
    text-rendering: optimizeLegibility;
  }

  body {
    font-family: 'Roboto', sans-serif;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.6;
    color: #333;
    background-color: #f2f2f2;
  }

  button, input, textarea, select {
    border: 0;
    outline: 0;
    font-family: inherit;
    font-size: 1rem;
    background-color: transparent;
  }

  button {
    cursor: pointer;
  }

  ul {
    list-style: none;
  }

  a {
    text-decoration: none;
  }

  .container {
    width: 100%;
    max-width: 1080px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 1rem;
    padding-right: 1rem;
  }
`;
