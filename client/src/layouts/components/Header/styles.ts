import styled from 'styled-components';

const Container = styled.div`
  background-color: #fff;
`;

const Wrapper = styled.div`
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  padding-top: 1.6rem;
  padding-bottom: 1.6rem;

  > a {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
  }

  > nav {
    display: flex;
    align-items: center;

    a {
      font-size: 1.4rem;
      font-weight: 500;
      color: #333;
      opacity: 0.3;
      transition: opacity 0.3s ease;

      &:not(:first-child) {
        margin-left: 3.2rem;
      }

      &:hover {
        opacity: 0.6;
      }

      &.active {
        opacity: 1;
      }
    }
  }
`;

export { Container, Wrapper };
