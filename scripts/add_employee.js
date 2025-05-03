document.addEventListener("DOMContentLoaded", function () {
    const birthdateInput = document.getElementById("Birthdate");
    const ageInput = document.getElementById("Age");

    // Calculate age from birthdate
    birthdateInput.addEventListener("change", function () {
        const birthdate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDifference = today.getMonth() - birthdate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        ageInput.value = age;
    });

    // Add comorbidities
    const addComorbidityButton = document.getElementById("AddComorbidity");
    const comorbiditiesContainer = document.getElementById("ComorbiditiesContainer");
    addComorbidityButton.addEventListener("click", function () {
        comorbiditiesContainer.style.display = "block"; // Ensure the container is visible
        const div = document.createElement("div");
        div.innerHTML = `
            <label>COMORBIDITY DETAILS:</label>
            <input type="text" name="ComorbiditiesDetails[]" required>
            <label>WITH MAINTENANCE MEDICATION (Yes/No):</label>
            <select name="MaintenanceMedication[]" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <label>NAME AND DOSAGE OF MAINTENANCE MEDICATION:</label>
            <input type="text" name="MedicationAndDosage[]" required>
            <button type="button" class="remove-button">Remove</button>
        `;
        comorbiditiesContainer.appendChild(div);

        // Add event listener to the "Remove" button
        div.querySelector(".remove-button").addEventListener("click", function () {
            div.remove();
        });
    });

    // Add surgeries
    const addSurgeryButton = document.getElementById("AddSurgery");
    const surgeryContainer = document.getElementById("SurgeryContainer");
    addSurgeryButton.addEventListener("click", function () {
        surgeryContainer.style.display = "block"; // Ensure the container is visible
        const div = document.createElement("div");
        div.innerHTML = `
            <label>NAME OF OPERATION:</label>
            <input type="text" name="OperationName[]">
            <label>DATE PERFORMED:</label>
            <input type="date" name="DatePerformed[]">
            <button type="button" class="remove-button">Remove</button>
        `;
        surgeryContainer.appendChild(div);

        // Add event listener to the "Remove" button
        div.querySelector(".remove-button").addEventListener("click", function () {
            div.remove();
        });
    });

    // Add clinic records
    const addClinicRecordButton = document.getElementById("AddClinicRecord");
    const clinicRecordContainer = document.getElementById("ClinicRecordContainer");
    addClinicRecordButton.addEventListener("click", function () {
        clinicRecordContainer.style.display = "block"; // Ensure the container is visible
        const div = document.createElement("div");
        div.innerHTML = `
            <label>DATE OF VISIT:</label>
            <input type="date" name="VisitDate[]">
            <label>COMPLAINTS:</label>
            <input type="text" name="Complaints[]">
            <label>INTERVENTION:</label>
            <input type="text" name="Intervention[]">
            <label>NURSE ON DUTY:</label>
            <input type="text" name="NurseOnDuty[]">
            <button type="button" class="remove-button">Remove</button>
        `;
        clinicRecordContainer.appendChild(div);

        // Add event listener to the "Remove" button
        div.querySelector(".remove-button").addEventListener("click", function () {
            div.remove();
        });
    });
});