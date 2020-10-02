import styled from 'styled-components';

const Container = styled.div``;

const Wrapper = styled.div`
  margin-top: 3.2rem;
  margin-bottom: 3.2rem;

  div {
    width: 100%;
    overflow-x: auto;

    table {
      width: 100%;
      border-collapse: collapse;

      thead,
      th {
        text-align: left;
      }

      th {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      }

      tr,
      th,
      td {
        font-size: 1.6rem;
        white-space: nowrap;
      }

      th,
      td {
        padding: 0.8rem 1.6rem;
      }

      td > button {
        margin: 0 0.8rem;
        font-size: 1.6rem;
        color: #3366cc;

        &:hover {
          text-decoration: underline;
        }
      }
    }
  }
`;

const Header = styled.div`
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2.4rem;

  button {
    font-size: 1.6rem;
    color: #3366cc;

    &:hover {
      text-decoration: underline;
    }
  }
`;

export { Container, Wrapper, Header };
