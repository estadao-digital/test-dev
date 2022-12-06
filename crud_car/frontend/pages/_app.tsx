import '../styles/globals.scss'
import "../styles/responsive_table.scss"
import "../styles/form.scss"

import type { AppProps } from 'next/app'

function MyApp({ Component, pageProps }: AppProps) {
  return <Component {...pageProps} />
}

export default MyApp
