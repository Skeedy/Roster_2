import { Component, OnInit } from '@angular/core';
import {FormControl, Validators} from "@angular/forms";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.scss']
})
export class ForgetPasswordComponent implements OnInit {
html: string;
disabled=  false;
requestDone = false;
errorNotFound = false;
  constructor( private rosterServ: RosterService) {
  }
  email = new FormControl('', [Validators.required, Validators.email]);

  getErrorMessage() {
    if (this.email.hasError('required')) {
      return 'You must enter a value';
    }

    return this.email.hasError('email') ? 'Not a valid email' : '';
  }
  ngOnInit(): void {

  }
  sendPasswordRequest(){
    this.disabled = true;
    this.rosterServ.sendEmailPassword(this.email.value).subscribe((data)=>{
      console.log(data)
      this.requestDone = true;
      this.html = 'An email has been sent, please check it to change your password'
    }, (err)=>{
      console.log(err.message);
      this.disabled = false;
      this.errorNotFound = true;
      this.html = 'This email is not in our database';
  })
  }
}
