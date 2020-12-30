import { InstanceOnePipe } from './instance-one.pipe';

describe('InstanceOnePipe', () => {
  it('create an instance', () => {
    const pipe = new InstanceOnePipe();
    expect(pipe).toBeTruthy();
  });
});
