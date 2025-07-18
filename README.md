# Covid Tracker

This website reads and displays data stored in a JSON file.
The file shows the impact of the coronavirus per country and per day.
The project is built using the MVC architecture.

**Source data**:
[https://www.data.gouv.fr/datasets/coronavirus-covid19-evolution-par-pays-et-dans-le-monde-maj-quotidienne/](https://www.data.gouv.fr/datasets/coronavirus-covid19-evolution-par-pays-et-dans-le-monde-maj-quotidienne/)


## Usage

```bash
php -S localhost:8000
```

Then visit: [http://localhost:8000](http://localhost:8000)


## Notions

### New notions

* MVC architecture
* Reusable HTML components
* Use of a chart library
* Reading and using data from a JSON file

## Screenshots

### Data table
Filters are additive and can be used with each others

- Raw table
<img width="1859" height="959" alt="image" src="https://github.com/user-attachments/assets/a188a4dd-5cd1-48ee-97f2-0398596bfa16" />

- Country filter
<img width="269" height="444" alt="image" src="https://github.com/user-attachments/assets/7c9e4339-0d20-4daf-9f2f-dc6bd5f2602f" />

- Result 
<img width="1532" height="845" alt="image" src="https://github.com/user-attachments/assets/c4c9a733-6b90-4254-a3d4-3e3f4cb9a471" />

### Ranking first 20 countries per field
<img width="1861" height="966" alt="image" src="https://github.com/user-attachments/assets/58bf58be-4467-4be9-aa44-5c49095e7adf" />

### Death count per time
<img width="703" height="332" alt="image" src="https://github.com/user-attachments/assets/b699cffa-14bc-450b-a70e-751637c50bf2" />
