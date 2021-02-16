import React from 'react';

// import { Container } from './styles';

const Layouts: React.FC = ({children}) => {
  return (
    <>
    <header>
      <div className="container">
        <h1>Estadão Carros</h1>
      </div>
      {children}
    </header>
    <footer>
      <div className="conatainer">
          <div className="text-center">Feito com amor e TypeScript</div>
      </div>
    </footer>
    </>
  );
}

export default Layouts;