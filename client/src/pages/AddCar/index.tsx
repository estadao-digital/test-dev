import React, { FormEvent, useCallback, useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';

import api from '../../services/api';
import Layout from '../../layouts/Layout';

import { Container, Wrapper, Header } from './styles';

interface BrandDTO {
  id: number;
  name: string;
}

const AddCar: React.FC = () => {
  const [loading, setLoading] = useState(true);
  const [brands, setBrands] = useState<BrandDTO[]>([]);

  const history = useHistory();

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

  const handleGoBack = useCallback(() => {
    history.goBack();
  }, [history]);

  const handleSubmit = useCallback(
    async (event: FormEvent<HTMLFormElement>) => {
      try {
        event.preventDefault();

        await api.post('/cars', {
          model,
          brand_id: brand,
          year,
        });

        history.push('/cars');
      } catch (err) {
        throw new Error(err);
      }
    },
    [model, brand, year, history],
  );

  return (
    <Layout>
      <Container>
        <Wrapper className="container">
          <Header>
            <h1>Add new</h1>
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
            <input
              name="year"
              placeholder="Year"
              value={year}
              onChange={event => setYear(event.target.value)}
            />
            <button type="submit">Save</button>
          </form>
        </Wrapper>
      </Container>
    </Layout>
  );
};

export default AddCar;
