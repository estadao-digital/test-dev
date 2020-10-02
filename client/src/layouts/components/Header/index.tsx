import React from 'react';
import { Link, NavLink } from 'react-router-dom';

import { Container, Wrapper } from './styles';

const Header: React.FC = () => {
  return (
    <Container>
      <Wrapper className="container">
        <Link to="/">Logo</Link>
        <nav>
          <NavLink to="/" exact activeClassName="active">
            Home
          </NavLink>
          <NavLink to="/cars" activeClassName="active">
            Cars
          </NavLink>
        </nav>
      </Wrapper>
    </Container>
  );
};

export default Header;
