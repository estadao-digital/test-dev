import React, { useCallback, useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import api from '../../services/api';

import Layout from '../../layouts/Layout';

import { Container, Wrapper, Header } from './styles';

interface CarDTO {
  id: number;
  brand_id: number;
  model: string;
  year: string;
}

const Cars: React.FC = () => {
  const [loading, setLoading] = useState(true);
  const [cars, setCars] = useState<CarDTO[]>([]);

  const history = useHistory();

  useEffect(() => {
    function loadCars() {
      api.get('/cars').then(response => {
        setCars(response.data.cars);

        setLoading(false);
      });
    }

    loadCars();
  }, []);

  const handleAddCar = useCallback(() => {
    history.push('/cars/add');
  }, [history]);

  const handleEditCar = useCallback(
    (id: number) => {
      history.push('/cars/edit', id);
    },
    [history],
  );

  const handleDeleteCar = useCallback(
    async (id: number) => {
      if (window.confirm('Você deseja excluir este registro?')) {
        const filterCars = cars.filter(car => car.id !== id);

        setCars(filterCars);

        await api.delete(`/cars/${id}`);
      }
    },
    [cars],
  );

  return (
    <Layout>
      <Container>
        <Wrapper className="container">
          <Header>
            <h1>Cars</h1>
            <button type="button" onClick={handleAddCar}>
              Add new
            </button>
          </Header>
          <div>
            <table>
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Model</th>
                  <th>Brand</th>
                  <th>Year</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                {loading ? (
                  <tr>
                    <td colSpan={5}>Loading...</td>
                  </tr>
                ) : (
                  cars.map(car => (
                    <tr key={car.id}>
                      <td>{car.id}</td>
                      <td>{car.model}</td>
                      <td>{car.brand_id}</td>
                      <td>{car.year}</td>
                      <td>
                        <button
                          type="button"
                          onClick={() => handleEditCar(car.id)}
                        >
                          Edit
                        </button>
                        <button
                          type="button"
                          onClick={() => handleDeleteCar(car.id)}
                        >
                          Remove
                        </button>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </Wrapper>
      </Container>
    </Layout>
  );
};

export default Cars;
