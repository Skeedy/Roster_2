import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {animate, style, transition, trigger} from "@angular/animations";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-delete-confirmation',
  templateUrl: './delete-confirmation.component.html',
  styleUrls: ['./delete-confirmation.component.scss'],
  animations: [
    trigger('dialog', [
      transition('void => *', [
        style({ transform: 'scale3d(.3, .3, .3)' }),
        animate(100)
      ]),
      transition('* => void', [
        animate(100, style({ transform: 'scale3d(.0, .0, .0)' }))
      ])
    ])
  ]
})
export class DeleteConfirmationComponent implements OnInit {
  @Input() closable = true;
  @Input() visible: boolean;
  @Input() player: Player;
  @Output() visibleChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(public searchServ: PlayerListService, public rosterServ: RosterService) { }

  ngOnInit(): void {
  }
  close() {
    this.visible = false;
    this.visibleChange.emit(this.visible);
  }
  deleteChar(id) {
    this.searchServ.deleteChar(id).subscribe( _ => {
        this.rosterServ.getRoster().subscribe();
      }
    );
  }
}
