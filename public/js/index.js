let currentPage = 1;
let searchTerm = '';

const searchInput = document.querySelector('.inputSearch');
const searchButton = document.querySelector('.searchBtn');
let searchTimeout;

const fetchDataRoute = window.routes.fetchData;
const insertDataRoute = window.routes.insertData;
// const updateDataRoute = window.routes.updateData;
// const deleteDataRoute = window.routes.deleteData;


async function loadMoreRecords() {
    try {
        document.getElementById('loadingMessage').style.display = 'block';

        const response = await fetch(`${fetchDataRoute}?page=${currentPage}&searchTerm=${searchTerm}`);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        if (data.data.length === 0) {
            document.getElementById('showMoreButton').textContent = 'NO Records Found';
            return;
        }

        const table = document.querySelector('.tabelBody');
        data.data.forEach(employee => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${employee.id}</td>
                <td>${employee.name}</td>
                <td>${employee.email}</td>
                <td>${employee.role}</td>
                <td>${employee.age}</td>
                <td>${employee.city}</td>
                <td>
                    <img src="/uploads/${employee.image_name}" class="student_img" alt="">
                </td>
                <td>
                    <a href="#editEmployeeModal" class="edit" data-toggle="modal" data-id="${employee.id}"><i
                        class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="${employee.id}"><i
                        class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                </td>
            `;
            table.appendChild(row);
        });

        currentPage++;


        document.getElementById('loadingMessage').style.display = 'none';
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

document.getElementById('showMoreButton').addEventListener('click', loadMoreRecords);


searchInput.addEventListener('input', (e) => {
    searchTerm = e.target.value;
    currentPage = 1;
    serachFunction(currentPage, searchTerm)

});





loadMoreRecords();


/* **************************** ----------------------------
------------------------------ functions --------------------------------
------------------------ ************************************
*/

function serachFunction(current, serach) {

    const url = `${fetchDataRoute}?page=${current}&search=${serach}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const noRecord = document.querySelector(".no-record");
            const table = document.querySelector('.tabelBody');
            table.innerHTML = '';

            if (data.data.length === 0) {
                noRecord.style.display = "block";

            } else {
                noRecord.style.display = "none";


                data.data.forEach(employee => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${employee.id}</td>
                        <td>${employee.name}</td>
                        <td>${employee.email}</td>
                        <td>${employee.role}</td>
                        <td>${employee.age}</td>
                        <td>${employee.city}</td>
                        <td>
                            <img src="/uploads/${employee.image_name}" class="student_img" alt="">
                        </td>
                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal" data-id="${employee.id}"><i
                                class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="${employee.id}"><i
                                class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    `;
                    table.appendChild(row);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}








/* **************************** ----------------------------
------------------------------ insertion process  --------------------------------
------------------------ ************************************
*/

const getModal = document.querySelector(".modal");
const getBody = document.body;

function removeModal() {
    getBody.classList.remove("open-modal");
    getModal.style.display = "none";
}

function clearFields() {
    document.querySelector(".addName").value = "";
    document.querySelector(".addEmail").value = "";
    document.querySelector(".addRole").value = "";
    document.querySelector(".addAge").value = "";
    document.querySelector(".addCity").value = "";
    document.querySelector(".addImage").value = "";
}

const addEmploye = document.querySelector(".addEmploye");

const addImageInput = document.querySelector(".addImage");
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const insertData = async (e) => {
    e.preventDefault();
    const addName = document.querySelector(".addName").value;
    const addEmail = document.querySelector(".addEmail").value;
    const addRole = document.querySelector(".addRole").value;
    const addAge = document.querySelector(".addAge").value;
    const addCity = document.querySelector(".addCity").value;
    const fileImage = addImageInput.files[0];

    let object = {
        addName: addName,
        addEmail: addEmail,
        addRole: addRole,
        addAge: addAge,
        addCity: addCity,
        fileImage: fileImage,
    }
    let json_format = JSON.stringify(object);

    // const formData = new FormData();
    // formData.append("addName", addName);
    // formData.append("addEmail", addEmail);
    // formData.append("addRole", addRole);
    // formData.append("addAge", addAge);
    // formData.append("addCity", addCity);
    // formData.append("addImage", fileImage);

    try {
        const fetchData = await fetch(insertDataRoute, {
            method: "POST",
            body: json_format,
            headers: {
                "content-type": 'application/json'
            },
        });
        const result = await fetchData.json();
        console.log(result);
        if (result.insert === "success") {
            removeModal();
            loadMoreRecords();
            clearFields();
        } else {
            console.log("Failed to fetch inserted data");
        }
    } catch (error) {
        console.log(error);
    }
};

addEmploye.addEventListener("click", insertData);
