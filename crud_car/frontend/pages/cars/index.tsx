import type { NextPage } from 'next'
import Head from 'next/head';
import Link from 'next/link'
import { useState, useEffect } from 'react'
import { FaCar, FaPlus } from 'react-icons/fa';

const Cars: NextPage = (url: RequestInfo = "http://0.0.0.0/api/carros", method: string = "get") => {

  const [loading, setLoading] = useState(false)
  const [data, setData] = useState(null)

  const fetchData = async (url: RequestInfo, method: string) => {
    try {
      setLoading(true)

      const response = await fetch(url, {
        "method": method.toUpperCase()
      })

      const data = await response.json()
      if (!data) throw 'No cars found!'
      setData(data)


    } catch (error) {
      console.log(error);
    }
    finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    fetchData(url, method)
  }, []);

  return (
    <>
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
      <div className='new-car-nav'>
        <p className='' data-label='Add New Car' colSpan={4}><Link href={{ pathname: "cars/new" }}>Add New Car {FaPlus()}{FaCar()}</Link></p>
      </div>
      <table className="table table-stripped table-hover">
        <thead className="table-head">
          <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody className='table-body'>
          {loading && !data && <tr className="container">
            <td colSpan={3}>Loading</td>
          </tr>
          }

          {
            data && data.map((car) => (
              <tr key={car.id}>

                <td data-label="Brand">{car.brand}</td>
                <td data-label="Model">{car.model}</td>
                <td data-label="Year">{car.year}</td>
                <td data-label="Details">
                  <Link href={{ pathname: `cars/${car.id}`, query: { method: "GET" } }}> <FaCar /></Link>
                </td>
              </tr>
            ))
          }
        </tbody>
      </table>
    </>
  )
}

export default Cars
