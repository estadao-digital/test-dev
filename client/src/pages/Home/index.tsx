import React from 'react';

import Layout from '../../layouts/Layout';

import { Container, Wrapper } from './styles';

const Home: React.FC = () => {
  return (
    <Layout>
      <Container>
        <Wrapper className="container">
          <h1>Home</h1>
        </Wrapper>
      </Container>
    </Layout>
  );
};

export default Home;
