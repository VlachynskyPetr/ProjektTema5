<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osobní formulář</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h3>Osobní údaje</h3>
        </div>

        <div class="card-body">
            <form>

                <div class="mb-3">
                    <label for="jmeno" class="form-label">Jméno</label>
                    <input type="text" class="form-control" id="jmeno" required>
                </div>

                <div class="mb-3">
                    <label for="prijmeni" class="form-label">Příjmení</label>
                    <input type="text" class="form-control" id="prijmeni" required>
                </div>

                <div class="mb-3">
                    <label for="datumNarozeni" class="form-label">Datum narození</label>
                    <input type="date" class="form-control" id="datumNarozeni" required>
                </div>

                <div class="mb-3">
                    <label for="mistoNarozeni" class="form-label">Místo narození</label>
                    <select class="form-select" id="mistoNarozeni" required>
                        <option selected disabled>Vyberte město</option>
                        <option>Praha</option>
                        <option>Brno</option>
                        <option>Ostrava</option>
                        <option>Plzeň</option>
                        <option>Olomouc</option>
                        <option>Zlín</option>
                        <option>Uherské Hradiště</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="vyska" class="form-label">
                        Výška: <span id="vyskaHodnota">175</span> cm
                    </label>
                    <input type="range" class="form-range"
                           min="100" max="220" value="175"
                           id="vyska">
                </div>

                <div class="mb-3">
                    <label for="vaha" class="form-label">
                        Váha: <span id="vahaHodnota">70</span> kg
                    </label>
                    <input type="range" class="form-range"
                           min="30" max="200" value="70"
                           id="vaha">
                </div>

                <button type="submit" class="btn btn-primary">
                    Odeslat
                </button>

            </form>
        </div>
    </div>
</div>

<script>
    const vyska = document.getElementById("vyska");
    const vyskaHodnota = document.getElementById("vyskaHodnota");

    vyska.addEventListener("input", () => {
        vyskaHodnota.textContent = vyska.value;
    });

    const vaha = document.getElementById("vaha");
    const vahaHodnota = document.getElementById("vahaHodnota");

    vaha.addEventListener("input", () => {
        vahaHodnota.textContent = vaha.value;
    });
</script>

</body>
</html>