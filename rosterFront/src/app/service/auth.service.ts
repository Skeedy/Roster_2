import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, from } from 'rxjs';
import { map } from 'rxjs/operators';


import { Login } from '../class/login';
import { Roster } from '../class/roster';


@Injectable({
  providedIn: 'root'
})
export class AuthService {

//   private loginSubject: BehaviorSubject<Login>;
//   private loginObs: Observable<Login>;
//
//   private userSubject: BehaviorSubject<Roster>;
//   private userObs: Observable<Roster>;
//
//   constructor(private http: HttpClient) {
//     const token = JSON.parse(localStorage.getItem(Globals.APP_USER_TOKEN));
//     this.loginSubject = new BehaviorSubject<Login>(token);
//     this.loginObs = this.loginSubject.asObservable();
//
//     const roster = JSON.parse(localStorage.getItem(Globals.APP_USER));
//     this.userSubject = new BehaviorSubject<Roster>(roster);
//     this.userObs = this.userSubject.asObservable();
//   }
//   public login(username: string, password: string) {
//     return this.http.post<Login>(Globals.APP_API + 'login_check', { username, password })
//       .pipe(map((data) => {
//         if (data && data.token) {
//           localStorage.setItem(Globals.APP_USER_TOKEN, JSON.stringify(data));
//           this.loginSubject.next(data);
//         }
//         return data;
//       }));
//   }
//
//   public get tokenData() {
//     return JSON.parse(localStorage.getItem(Globals.APP_USER_TOKEN));
//   }
//
//   public isConnected(): boolean {
//     return !!this.loginSubject.value && !!this.userSubject.value;
//   }
//
//   public saveProfile(fname, lname, phone, city) {
//     const data = {fname, lname, phone, city};
//     return this.http.put<User>(Globals.APP_API + 'auth/profile/edit', data)
//       .pipe(map((user) => {
//         if (user) {
//           localStorage.setItem(Globals.APP_USER, JSON.stringify(user));
//           this.userSubject.next(user);
//           this.userObs = this.userSubject.asObservable();
//         }
//         return this.userSubject.value;
//       }));
//   }
//
//   public logout() {
//     localStorage.removeItem(Globals.APP_USER_TOKEN);
//     localStorage.removeItem(Globals.APP_USER);
//     this.loginSubject.next(null);
//     this.userSubject.next(null);
//   }
//
//   public profile() {
//     return this.http.get<User>(Globals.APP_API + 'auth/profile', {})
//       .pipe(map((user) => {
//         if (user) {
//           localStorage.setItem(Globals.APP_USER, JSON.stringify(user));
//           this.userSubject.next(user);
//           this.userObs = this.userSubject.asObservable();
//         }
//         return user;
//       }));
//   }
//
//   public register(data) {
//     const obj = {
//       fname: data.fname,
//       lname: data.lname,
//       username: data.username,
//       phone: data.phone,
//       city: data.city,
//       email: data.email,
//       password: data.password
//     };
//     return this.http.post(Globals.APP_API + 'auth/register', obj);
//   }
//
//   public get currentUser(): User|null {
//     return this.userSubject.value;
//   }
}
