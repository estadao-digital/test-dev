import React, { FormEvent, useCallback, useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import * as Yup from 'yup';

import api from '../../services/api';
import Layout from '../../layouts/Layout';

import { Container, Wrapper, Header } from './styles';

interface BrandDTO {
  id: number;
  name: string;
}

interface CarDTO {
  id: number;
  brand_id: number;
  model: string;
  year: string;
}

const EditCar: React.FC = () => {
  const [loading, setLoading] = useState(true);
  const [brands, setBrands] = useState<BrandDTO[]>([]);
  const [car, setCar] = useState<CarDTO>({} as CarDTO);
  const [errors, setErrors] = useState<Yup.ValidationError[]>([]);

  const history = useHistory();

  const id = history.location.state;

  const [model, setModel] = useState('');
  const [brand, setBrand] = useState('');
  const [year, setYear] = useState('');

  useEffect(() => {
    function loadBrands() {
      api.get('/brands').then(response => {
        setBrands(response.data.brands);

        setLoading(false);
      });
    }

    loadBrands();
  }, []);

  useEffect(() => {
    function loadCar() {
      api.get(`/cars/${id}`).then(response => {
        setCar(response.data.car);
      });
    }

    loadCar();

    setModel(car.model);
    setBrand(String(car.brand_id));
    setYear(car.year);
  }, [id, car.model, car.brand_id, car.year]);

  const handleGoBack = useCallback(() => {
    history.goBack();
  }, [history]);

  const handleSubmit = useCallback(
    async (event: FormEvent<HTMLFormElement>) => {
      try {
        event.preventDefault();

        const schema = Yup.object().shape({
          brand_id: Yup.string().required('The brand is required.'),
          model: Yup.string().required('The model is required.'),
          year: Yup.string().required('The year is required.'),
        });

        await schema.validate(
          {
            model,
            brand_id: brand,
            year,
          },
          {
            abortEarly: false,
          },
        );

        await api.put(`/cars/${id}`, {
          model,
          brand_id: brand,
          year,
        });

        history.push('/cars');
      } catch (err) {
        if (err instanceof Yup.ValidationError) {
          setErrors(err.inner);
        }
      }
    },
    [id, model, brand, year, history],
  );

  return (
    <Layout>
      <Container>
        <Wrapper className="container">
          <Header>
            <h1>Edit</h1>
            <button type="button" onClick={handleGoBack}>
              Go Back
            </button>
          </Header>
          <form onSubmit={handleSubmit}>
            <input
              name="model"
              placeholder="Model"
              value={model}
              onChange={event => setModel(event.target.value)}
            />
            {errors.map(
              error =>
                error.path === 'model' && (
                  <small key={error.path}>{error.message}</small>
                ),
            )}
            <select
              name="brand"
              value={brand}
              onChange={event => setBrand(event.target.value)}
            >
              {loading ? (
                <option value="">Loading...</option>
              ) : (
                <option value="">Select the brand</option>
              )}
              {brands.map(item => (
                <option key={item.id} value={item.id}>
                  {item.name}
                </option>
              ))}
            </select>
            {errors.map(
              error =>
                error.path === 'brand_id' && (
                  <small key={error.path}>{error.message}</small>
                ),
            )}
            <input
              name="year"
              placeholder="Year"
              value={year}
              onChange={event => setYear(event.target.value)}
            />
            {errors.map(
              error =>
                error.path === 'year' && (
                  <small key={error.path}>{error.message}</small>
                ),
            )}
            <button type="submit">Save</button>
          </form>
        </Wrapper>
      </Container>
    </Layout>
  );
};

export default EditCar;
