import type { NextPage } from 'next'
import styles from '../styles/Home.module.css'
import Cars from './cars/index'
import CustomHead from './head'


const Home: NextPage = () => {


  return (
    <div className={styles.container}>

      {CustomHead("Home")}

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
