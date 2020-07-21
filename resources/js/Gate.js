export default class Gate{
    constructor(user){
        this.user=user;
    }
    isAdmin(){
        return this.user.type==='admin';
    }
    isStudent(){
        return this.user.type==='student';
    }
    isTeacher(){
        if(this.user.type==='admin'|| this.user.type==='supervisor'|| this.user.type==='external')
        return true;
    }
    isNotVerified(){
        return this.user.email_verified_at===null;
    }
}