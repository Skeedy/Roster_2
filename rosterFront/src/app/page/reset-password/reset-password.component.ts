import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {MustMatch} from "../../functions/must-match.validator";
import {RosterService} from "../../service/roster.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {
  public passwordForm: FormGroup;
  private token : string;
  changeDone = false;
  constructor(private route: ActivatedRoute, private router: Router, private fb: FormBuilder, public rosterServ : RosterService) { }
  html : string;
  errorHtml : string;
  error = false;
  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      this.token = params['token'];
      if (!this.token){
        this.router.navigate(['/']);
      }
    });
    this.passwordForm = this.fb.group({
        password: new FormControl('', Validators.compose([
          Validators.required,
          Validators.pattern('^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{8,}$')
        ])),
        confirmPassword: [ null, Validators.required],
      },
      { validator: MustMatch('password', 'confirmPassword')
      });
  }
  get password() {
    return this.passwordForm.get('password');
  }
  get f() { return this.passwordForm.controls; }

  changePassword(){
    const val = this.passwordForm.value;
    this.rosterServ.changePassword(val, this.token).subscribe((data)=>{
      this.html = 'Your password has been changed successfully';
      this.changeDone = true;
    },(err)=>{
      this.error = true;
      this.errorHtml = err.error.response;
    })
  }
}
