import { takeLatest, call, put, all } from 'redux-saga/effects';
import { toast } from 'react-toastify';

import api from '../../../services/api';
import {
  updateCarSuccess,
  updateCarFailure,
  reloadComplete,
  addCarSuccess,
  addCarFailure,
} from './actions';

export function* updateCar({ id, payload }) {
  try {
    const response = yield call(api.put, `carros/${id}`, payload.carro);

    toast.success('Carro atualizado com sucesso!');

    yield put(updateCarSuccess(response.data));
    yield put(reloadComplete());
  } catch (err) {
    toast.error('Erro ao atualizar carro!');
    yield put(updateCarFailure());
  }
}

export function* addCar({ payload }) {
  try {
    const response = yield call(api.post, 'carros', payload.data);
    toast.success('Carro cadastrado com sucesso!');

    yield put(addCarSuccess(response.data));
    yield put(reloadComplete());
  } catch (err) {
    toast.error('Erro cadastrar novo carro!');
    yield put(addCarFailure());
  }
}

export function* removeCar(data) {
  try {
    yield call(api.delete, `carros/${data.id}`);
    toast.success('Carro deletado com sucesso!');
    yield put(reloadComplete());
  } catch (err) {
    toast.error('Erro ao deletar carro!');
    yield put(updateCarFailure());
  }
}

export default all([
  takeLatest('@car/UPDATE_REQUEST', updateCar),
  takeLatest('@car/ADD_REQUEST', addCar),
  takeLatest('@car/REMOVE', removeCar),
]);
