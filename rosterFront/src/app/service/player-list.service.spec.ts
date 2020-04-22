import { TestBed } from '@angular/core/testing';

import { PlayerListService } from './player-list.service';

describe('PlayerListService', () => {
  let service: PlayerListService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PlayerListService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
