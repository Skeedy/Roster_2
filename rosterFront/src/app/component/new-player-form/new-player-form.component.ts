import {Component, ComponentFactoryResolver, OnInit, ViewChild, ViewContainerRef} from '@angular/core';
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";
import {AddPlayerComponent} from "../add-player/add-player.component";

@Component({
  selector: 'app-new-player-form',
  templateUrl: './new-player-form.component.html',
  styleUrls: ['./new-player-form.component.scss']
})


export class NewPlayerFormComponent implements OnInit {
  @ViewChild('formBlock', { read: ViewContainerRef, static: true }) formBlock: ViewContainerRef;
  constructor(public searchServ: PlayerListService,
              public rosterServ: RosterService,
              public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,) { }

  ngOnInit(): void {
    console.log(this.searchServ.nbForm)
  }
  addCharForm() {
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(AddPlayerComponent);
    this.formBlock.createComponent(componentFactory);
    this.searchServ.formUp = true;
    this.searchServ.nbForm++;
    console.log('nbFrom : ' + this.searchServ.nbForm +'/ nbPlayer : '+ this.rosterServ.nbPlayer)
    console.log(this.rosterServ.nbPlayer);
  }

  submitPlayers() {
    if(this.searchServ.playerList.playersIds.length === this.searchServ.nbForm){
      this.rosterServ.postPlayer().subscribe((data) => {
        if (data) {
          this.rosterServ.getRoster().subscribe();
          this.searchServ.isSubmitted = false;
          this.searchServ.isDone = true;
          this.searchServ.formUp = false;
        }
      });
    }
    else{
      console.log('erreur')
    }
  }
}
