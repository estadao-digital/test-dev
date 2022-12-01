from requests import post

car_list = [
    {"model": "Stillo", "brand": "FIAT", "year": 2012},
    {"model": "Siena", "brand": "FIAT", "year": 2017},
    {"model": "Up!", "brand": "VolksWagen", "year": 2021},
    {"model": "Top Sport", "brand": "Miura", "year": 1992},
    {"model": "AC200", "brand": "Adamo", "year": 1990},
    {"model": "iEV 40", "brand": "JAC", "year": 2021},
    {"model": "2300", "brand": "Alfa Romeo", "year": 1976},
    {"model": "A3", "brand": "Audi", "year": 2006},
    {"model": "Série 2", "brand": "Bianco", "year": 1979},
    {"model": "X4", "brand": "BMW", "year": 2022},
]


for car in car_list:
    post(url="http://0.0.0.0/api/carros", data=car)
