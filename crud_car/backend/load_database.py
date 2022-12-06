from json import dumps, loads
from http.client import HTTPConnection


def get_or_post_api_cars(method: str = "GET", body: dict | None = None):
    headers = {"Content-type": "application/json"}
    conn = HTTPConnection("localhost")
    conn.request(method, "/api/carros/", headers=headers, body=dumps(body))
    res = conn.getresponse()
    if method == "GET":
        return loads(res.read())


def check_db_data():
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
        {"model": "Gol", "brand": "VolksWagen", "year": 2018},
        {"model": "Argo", "brand": "FIAT", "year": 2018},
    ]
    try:
        api_cars = get_or_post_api_cars()

        if not api_cars:
            for car in car_list:
                get_or_post_api_cars(method="POST", body=car)
            return print(
                f"\033[92m\n\nFIRST DB LOAD SUCCESSFULY FINISHED: {car_list} \n\n\033[0m"
            )
        return print(f"\033[93m\n\nBD ALREADY LOADED: {api_cars} \n\n\033[0m")
    except Exception as exc:
        print(f"\033[91m\n\nVerify docker container and try again: {exc}\n\n\033[0m")


check_db_data()
