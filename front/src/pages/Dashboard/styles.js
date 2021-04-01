import styled from 'styled-components';
import { Fab, TableRow } from '@material-ui/core';

export const Container = styled.div`
  max-width: 600px;
  margin: 50px auto;

  display: flex;
  flex-direction: column;

  header {
    display: flex;
    align-self: center;
    align-items: center;

    h1 {
      color: #7159c1;
      font-size: 29px;
    }
  }

  ul {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 15px;
    margin-top: 30px;
  }
`;

export const FabButton = styled(Fab)`
  margin: 10px;
`;
