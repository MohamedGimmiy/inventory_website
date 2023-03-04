
import token from "./token";
import AppStorage from "./AppStorage";

class User{
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const user_name = res.data.name;
        if(token.isValid(access_token)){
            AppStorage.store(access_token, user_name);
        }
    }

    hasToken(){
        const storeToken = localStorage.getItem('token');
        if(storeToken){
            return token.isValid(storeToken) ? true : false;
        }
    }

    loggedIn(){
        return this.hasToken();
    }

    name(){
        if(this.loggedIn()){
            return localStorage.getItem('user');
        }
    }
    id(){
        if(this.loggedIn()){
            const payload = token.payload(localStorage.getItem('token'));
            return payload.sub;
        }
        return false;
    }
}

export default User = new User();
