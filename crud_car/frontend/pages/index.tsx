import type { NextPage } from 'next'
import Head from 'next/head'
import styles from '../styles/Home.module.css'
import Cars from './cars/index'


const Home: NextPage = () => {


  return (
    <div className={styles.container}>
      <Head>
        <title>CRUD Car</title>
        <meta name="description" content="Teste para o Estadão" />
        <link rel="icon" href="/favicon.svg" />
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
          crossorigin="anonymous"
        />
      </Head>

      <main className={styles.main}>
        <h1 className={styles.title}>
          This is CRUD CAR
        </h1>
        {Cars()}

      </main>
    </div>
  )
}

export default Home
