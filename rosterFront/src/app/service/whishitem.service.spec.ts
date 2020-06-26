import { TestBed } from '@angular/core/testing';

import { WhishitemService } from './whishitem.service';

describe('WhishitemService', () => {
  let service: WhishitemService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WhishitemService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
