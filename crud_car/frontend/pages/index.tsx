import type { NextPage } from 'next'
import Head from 'next/head'
import styles from '../styles/Home.module.css'
import Cars from './core'

const Home: NextPage = () => {

  Cars()

  return (
    <div className={styles.container}>
      <Head>
        <title>CRUD Car</title>
        <meta name="description" content="Teste para o Estadão" />
        <link rel="icon" href="/favicon.svg" />
      </Head>

      <main className={styles.main}>
        <h1 className={styles.title}>
          This is CRUD CAR
        </h1>

      </main>
    </div>
  )
}

export default Home
