import React from 'react';
import { Router } from 'react-router-dom';
import { Provider } from 'react-redux';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import Container from '@material-ui/core/Container';
import Box from '@material-ui/core/Box';
import Typography from '@material-ui/core/Typography';
import GlobalStyle from './styles/global';

import Routes from './routes';
import history from './services/history';
import store from './store';

function App() {
  return (
    <Provider store={store}>
      <Container fluid>
        <Box my={4}>
          <Typography variant="h4" component="h1" gutterBottom>
            Teste Dev
          </Typography>
          <Router history={history}>
            <Routes />
            <GlobalStyle />
            <ToastContainer autoClose={3000} />
          </Router>
        </Box>
      </Container>
    </Provider>
  );
}

export default App;
