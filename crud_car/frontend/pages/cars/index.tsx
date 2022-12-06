import Link from 'next/link'
import { useRouter } from 'next/router';
import { useState, useEffect } from 'react'
import { Button, Modal } from 'react-bootstrap';
import { FaCar, FaCheck, FaEye, FaPlus, FaTrash } from 'react-icons/fa';
import { FiRefreshCw } from 'react-icons/fi';
import CustomAlert from '../alert';
import CustomHead from '../head';
import CustomLoading from '../loading';

const Cars = (url: RequestInfo = "http://0.0.0.0/api/carros", method: string = "get") => {

  const [loading, setLoading] = useState(false)
  const [data, setData] = useState(null)
  const [show, setShow] = useState(false);
  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);
  const router = useRouter();


  const confirmDelet = async (e, url) => {
    setShow(false)
    setLoading(true)
    let message = null
    try {
      const response = await fetch(url, { method: "DELETE" })

      if (response.status === 200) {
        CustomAlert({ message: "Car deleted successfully.", variant: "success" })
      }

    } catch (error) {
      message = error;
      CustomAlert({ message: error, variant: "danger" })
      throw error;
    } finally {
      setLoading(false)
      router.reload()
    }
  }

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
      CustomAlert({ message: error, variant: "danger" });
    }
    finally {
      setLoading(false)
    }
  }

  const ModalConfirm = (props: any) => {
    return (
      <>
        <Modal show={show} onHide={handleClose}>
          <Modal.Header closeButton>
            <Modal.Title>{props.title}</Modal.Title>
          </Modal.Header>

          <Modal.Footer>
            <Button variant="secondary" onClick={handleClose}>
              Close
            </Button>
            <Button variant="danger" onClick={(e) => confirmDelet(e, `http://0.0.0.0/api/carros/${props.carId}`)} ><FaCheck /></Button>
          </Modal.Footer>

        </Modal>
      </>)
  }

  useEffect(() => {
    fetchData(url, method)
  }, []);



  return (
    <>
      {CustomHead("CRUD Car")}
      <div className='new-car-nav'>
        <Link href={{ pathname: "cars/new" }}><Button> Add New Car <FaPlus /> <FaCar /></Button> </Link>
      </div>
      <table className="table table-stripped table-hover">
        <thead className="table-head">
          <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody className='table-body'>
          {loading && !data && <tr className="container">
            <td colSpan={4}>{CustomLoading()}</td>
          </tr>
          }

          {
            data && data.map((car) => (
              <tr key={car.id}>

                <td data-label="Brand">{car.brand}</td>
                <td data-label="Model">{car.model}</td>
                <td data-label="Year">{car.year}</td>
                <td data-label="Actions">
                  <div className='car-actions'>
                    <Link className='car-details-link' href={{ pathname: `cars/${car.id}`, query: { method: "GET" } }}> <FaEye /></Link>
                    <Link className='car-details-link' href={{ pathname: `cars/update`, query: { id: `${car.id}` } }}> <FiRefreshCw /></Link>

                    <span className='car-details-link' onClick={handleShow}>
                      <FaTrash />
                      <ModalConfirm title={`Delete ${car.brand} - ${car.model}?`} carId={car.id} />
                    </span>
                  </div>
                </td>
              </tr>
            ))
          }
          {!loading && !data && <tr className="container">
            <td colSpan={4}>No Cars Found</td>
          </tr>
          }
        </tbody>
      </table>
    </>
  )
}

export default Cars
