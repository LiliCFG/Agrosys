function cargarGrafica(parcela, idCanvas) {

    fetch("datos_grafica.php?parcela=" + parcela)
        .then(r => r.json())
        .then(data => {

            if (data.error) {
                alert("Error: " + data.error);
                return;
            }

            const ctx = document.getElementById(idCanvas).getContext("2d");

            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: "Temperatura (°C)",
                            data: data.temperatura,
                            borderColor: "red",
                            backgroundColor: "rgba(255,0,0,0.2)",
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: "Humedad (%)",
                            data: data.humedad,
                            borderColor: "blue",
                            backgroundColor: "rgba(0,0,255,0.2)",
                            borderWidth: 2,
                            tension: 0.3
                        }
                    ]
                }
            });

        })
        .catch(err => console.error(err));
}
