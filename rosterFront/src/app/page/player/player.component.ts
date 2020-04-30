import {Component, ComponentFactoryResolver, OnInit, Output, ViewChild, ViewContainerRef} from '@angular/core';
import {Player} from "../../class/player";
import {AddPlayerComponent} from "../../component/add-player/add-player.component";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";
import {Roster} from "../../class/roster";


@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit {
  @ViewChild(AddPlayerComponent)
  roster: Roster;
  private maxPlayer = 8;
  players: Player[];

  constructor(public viewContainerRef: ViewContainerRef,
              private componentFactoryResolver: ComponentFactoryResolver,
              public searchServ: PlayerListService,
              public rosterServ: RosterService) {
  }

  ngOnInit(): void {
    this.rosterServ.fillRoster();
    this.rosterServ.currentResponse.subscribe(data => {
      this.players = data.player;
    });
  }

  addCharForm() {
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(AddPlayerComponent);
    this.viewContainerRef.createComponent(componentFactory)
  }

  submitPlayers() {
    this.searchServ.postPlayer().subscribe((data) => {
      console.log(data)
    })
  }
}
