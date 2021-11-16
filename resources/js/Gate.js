export default class Gate{
    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.role == 'admin';
    }
    isStaff(){
        return this.user.role == 'staff';
    }
    isCustomer(){
        return this.user.role == 'customer';
    }
}