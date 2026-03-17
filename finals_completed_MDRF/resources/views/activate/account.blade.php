<form class="auth-group" method="POST" action="{{ route('account.activate') }}">
    @csrf
    <select name="type" class="account-type-select" required>
        <option value="" disabled selected>Select account type</option>
        <option value="landowner">Landowner</option>
        <option value="applicant">Applicant</option>
    </select>
    <input type="text" name="activation_code" placeholder="Enter your activation code" required>
    <button class="auth-button" type="submit">Activate</button>
</form>

<style>
.account-type-select {
    width: 100%;
    padding: 12px;
    border: 1px solidrgb(159, 159, 159);
    border-radius: 5px;
    color: #5d4a38;
    font-family: "Poppins", sans-serif;
    cursor: pointer;
    font-size: 0.87rem;
    margin-bottom: 15px;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none;
    outline: none;
    box-shadow: 0 2px 8px rgba(184, 155, 122, 0.07);

    background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6l4 4 4-4' stroke='%235d4a38' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 20px 20px;
}

.account-type-select:focus {
    border-color:rgb(0, 0, 0);
}

.account-type-select option {
    color: #5d4a38;
    background: #fff;
}
</style>