import { Component, OnInit } from '@angular/core';
import {Title} from "@angular/platform-browser";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {MustMatch} from "../../functions/must-match.validator";
import {RosterService} from "../../service/roster.service";
import {Roster} from "../../class/roster";

@Component({
  selector: 'app-edit-roster',
  templateUrl: './edit-roster.component.html',
  styleUrls: ['./edit-roster.component.scss']
})
export class EditRosterComponent implements OnInit {
  public registerFailed: boolean;
  public roster : Roster;
  public loading: boolean;
  public registerForm: FormGroup;
  public html: string;
  public showWarning = false;
  public deleteShow = false;

  constructor( private titleService: Title,
               private fb: FormBuilder,
               public rosterService: RosterService) { }

  ngOnInit(): void {
    this.titleService.setTitle('Edit - FFXIVRoster')
    this.rosterService.getRoster().subscribe((data)=>{
      this.roster = data;
      console.log(this.roster)
    });
    this.registerForm = this.fb.group({
        rostername: [ null ],
        // vérifie les caractères du champs input password
        email: new FormControl('', Validators.compose([
          Validators.pattern('^(([^<>()\\[\\]\\.,;:\\s@\\"]+(\\.[^<>()\\[\\]\\.,;:\\s@\\"]+)*)|(\\".+\\"))@(([^<>()[\\]\\.,;:\\s@\\"]+\\.)+[^<>()[\\]\\.,;:\\s@\\"]{2,})$')
        ]))
      });
  }

  get password() {
    return this.registerForm.get('password');
  }
  get f() { return this.registerForm.controls; }

  saveChanges(){
    const obj = this.registerForm.value;
    console.log(obj);
    this.rosterService.updateDatas(obj).subscribe(()=>{
      this.rosterService.refreshRoster().subscribe((data)=>{
        this.roster = data;
      });
      },(err)=>{
      this.html = err.message;
    });
  }
}


