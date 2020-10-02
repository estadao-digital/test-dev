import styled from 'styled-components';

const Container = styled.div``;

const Wrapper = styled.div`
  margin-top: 3.2rem;
  margin-bottom: 3.2rem;

  form {
    width: 100%;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;

    input,
    select {
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      font-size: 1.6rem;
      padding-left: 1.6rem;
      padding-right: 1.6rem;
      background-color: rgba(0, 0, 0, 0.05);

      &:not(:first-child) {
        margin-top: 0.8rem;
      }
    }

    > small {
      margin-top: 0.4rem;
      font-size: 1.4rem;
      color: #cc3366;
    }

    button {
      width: 100%;
      height: 50px;
      margin-top: 1.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      font-weight: 700;
      color: #fff;
      background-color: #3366cc;
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
