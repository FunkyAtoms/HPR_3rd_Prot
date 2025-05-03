document.addEventListener("DOMContentLoaded", function () {
    // Add Comorbidity
    const addComorbidityButton = document.getElementById("AddComorbidity");
    const comorbiditiesContainer = document.getElementById("ComorbiditiesContainer");

    addComorbidityButton.addEventListener("click", function () {
        const div = document.createElement("div");
        div.innerHTML = `
            <label>Comorbidity Details:</label>
            <input type="text" name="ComorbiditiesDetails[]" required>
            <label>Maintenance Medication (Yes/No):</label>
            <select name="MaintenanceMedication[]" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <label>Medication and Dosage:</label>
            <input type="text" name="MedicationAndDosage[]" required>
            <button type="button" onclick="this.parentElement.remove()">Remove</button>
        `;
        comorbiditiesContainer.appendChild(div);
    });

    // Add Surgery
    const addSurgeryButton = document.getElementById("AddSurgery");
    const surgeryContainer = document.getElementById("SurgeryContainer");

    addSurgeryButton.addEventListener("click", function () {
        const div = document.createElement("div");
        div.innerHTML = `
            <label>Surgery Name:</label>
            <input type="text" name="OperationName[]" required>
            <label>Date Performed:</label>
            <input type="date" name="DatePerformed[]" required>
            <button type="button" onclick="this.parentElement.remove()">Remove</button>
        `;
        surgeryContainer.appendChild(div);
    });

    // Add Clinic Record
    const addClinicRecordButton = document.getElementById("AddClinicRecord");
    const clinicRecordContainer = document.getElementById("ClinicRecordContainer");

    addClinicRecordButton.addEventListener("click", function () {
        const div = document.createElement("div");
        div.innerHTML = `
            <label>Visit Date:</label>
            <input type="date" name="VisitDate[]" required>
            <label>Complaints:</label>
            <input type="text" name="Complaints[]" required>
            <label>Intervention:</label>
            <input type="text" name="Intervention[]" required>
            <label>Nurse on Duty:</label>
            <input type="text" name="NurseOnDuty[]" required>
            <button type="button" onclick="this.parentElement.remove()">Remove</button>
        `;
        clinicRecordContainer.appendChild(div);
    });
});