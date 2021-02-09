import 'bootstrap/dist/css/bootstrap.min.css'
import GlobalStyles from '@/styles/globals'

import { Container } from 'react-bootstrap'

function MyApp({ Component, pageProps }) {
  return (
    <>
      <Container className="pt-3 my-3">
        <GlobalStyles />
        <Component {...pageProps} />
      </Container>
    </>
  )
}

export default MyApp
