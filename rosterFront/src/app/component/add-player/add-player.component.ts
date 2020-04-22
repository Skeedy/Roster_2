import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {PlayerListService} from "../../service/player-list.service";

@Component({
  selector: 'app-add-player',
  templateUrl: './add-player.component.html',
  styleUrls: ['./add-player.component.scss']
})
export class AddPlayerComponent implements OnInit {
  public search : any;
  private loading: boolean;
  public newPlayerFrom : FormGroup;
  public isSubmitted = false;
  public notFound = false;
  public newChar: any;
  constructor(private fb: FormBuilder, private http: HttpClient, public searchServ: PlayerListService) { }

  ngOnInit(): void {
    this.newPlayerFrom = this.fb.group({
      fname: [ null, Validators.required ],
      lname: [ null, Validators.required ],
      server: [ null, Validators.required ]});
  }
  // 'https://xivapi.com/character/search?name='+val.fname+'+'+val.lname+'&server='+ val.server
  get f() { return this.newPlayerFrom.controls; }
  submit(){
    const val = this.newPlayerFrom.value;
    this.loading = true;
    this.searchServ.searchPlayer(val.fname,val.lname,val.server).subscribe(data => {
        this.search = data;
      if(this.search.Results[0]) {
        this.newChar = this.search.Results[0];
        this.searchServ.addPlayer(this.newChar);
        this.isSubmitted = true;
        this.notFound = false;
        console.log(this.newChar);
      }
      else{
        this.notFound = true;
      }
    });
  }

}
