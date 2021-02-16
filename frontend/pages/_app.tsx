
import 'bootstrap/dist/css/bootstrap.min.css'
import Layouts from '../layouts'

const App = ({ Component, pageProps }) => {
  return (
  <Layouts>
    <Component {...pageProps} />
  </Layouts>
  
  )
}

export default App