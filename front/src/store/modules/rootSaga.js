import { all } from 'redux-saga/effects';

import carro from './carros/sagas';

export default function* rootSaga() {
  return yield all([carro]);
}
