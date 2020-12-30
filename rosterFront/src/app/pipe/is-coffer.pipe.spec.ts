import { IsCofferPipe } from './is-coffer.pipe';

describe('IsCofferPipe', () => {
  it('create an instance', () => {
    const pipe = new IsCofferPipe();
    expect(pipe).toBeTruthy();
  });
});
