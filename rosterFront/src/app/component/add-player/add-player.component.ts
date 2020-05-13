import {Component, ElementRef, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-add-player',
  templateUrl: './add-player.component.html',
  styleUrls: ['./add-player.component.scss']
})
export class AddPlayerComponent implements OnInit {
  public search : any;
  public isSearching = false;
  private loading: boolean;
  public newPlayerFrom : FormGroup;
  public isSubmitted = false;
  public notFound = false;
  public newChar: any;
  constructor(private fb: FormBuilder, private host: ElementRef<HTMLElement>, public searchServ: PlayerListService,
              public rosterServ: RosterService) { }

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
    this.isSearching = true;
    this.searchServ.searchPlayer(val.fname,val.lname,val.server).subscribe(data => {
        this.search = data;
      if(this.search.Results[0]) {
        this.newChar = this.search.Results[0];
        this.searchServ.addPlayer(this.newChar.ID);
        this.isSubmitted = true;
        this.notFound = false;
      }
      else{
        this.notFound = true;
        this.isSearching = false;
        this.loading = false;
      }
    });
  }
  remove(){
    this.isSubmitted = false;
    this.searchServ.removePlayer(this.newChar.ID);
    this.newChar = ''
    this.onCloseClicked();
  }
  onCloseClicked() {
    this.host.nativeElement.remove();
    this.searchServ.nbForm --;
    this.searchServ.formUp = false;
    console.log(this.searchServ.nbForm);
  }

}
